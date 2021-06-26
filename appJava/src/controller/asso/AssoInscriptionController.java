package controller.asso;

import controller.ControllerOne;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.TextArea;
import javafx.scene.control.TextField;
import javafx.scene.text.Text;
import org.json.JSONObject;
import org.jsoup.Connection;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import persistence.Asso;

import javax.net.ssl.SSLContext;
import javax.net.ssl.SSLSocketFactory;
import javax.net.ssl.TrustManager;
import javax.net.ssl.X509TrustManager;
import java.io.IOException;
import java.security.KeyManagementException;
import java.security.NoSuchAlgorithmException;
import java.security.cert.X509Certificate;

public class AssoInscriptionController extends ControllerOne {


    @FXML private TextField nameField;
    @FXML private TextField numeroRNAField;
    @FXML private TextField emailField;
    @FXML private TextArea descriptionField;
    @FXML private Text errorMsg;


    @FXML
    public void validAssoInscription(ActionEvent event)  {

        if( nameVerification()
            && numeroRNAVerification()
            && emailVerification()
            && descriptionVerification()
        ){
            boolean apiTest = false;
            try {
                apiTest = apiCheck();
            } catch(IOException e) {
                e.printStackTrace();
            }
            if( apiTest ){
                Asso asso = new Asso(
                        0,
                        numeroRNAField.getText(),
                        nameField.getText(),
                        emailField.getText(),
                        descriptionField.getText(),
                        new java.sql.Date(new java.util.Date().getTime())
                );
                ControllerAsso.loadAssoPaswordChoice(event, asso);
            }
            else {
                errorMsg.setText("Le numéro RNA est introuvable");
            }
        }
        else {
            errorMsg.setText("Champs incorrect");
        }
    }


    private boolean nameVerification(){
        return nameField.getText() != null && nameField.getText().length() <= 50;
    }

    private  boolean numeroRNAVerification(){
        if( numeroRNAField.getText().matches("^[W][0-9]{9}$") ) {
            return true;
        }
        else if( numeroRNAField.getText().matches("^[0-9]{9}$") ){
            numeroRNAField.setText('W'+numeroRNAField.getText());
            return true;
        }
        else {
            return false;
        }
    }

    // RFC 5322 Official Standard
    private boolean emailVerification(){
        return emailField.getText().matches("(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|\"(?:[\\x01-\\x08\\x0b\\x0c\\x0e-\\x1f\\x21\\x23-\\x5b\\x5d-\\x7f]|\\\\[\\x01-\\x09\\x0b\\x0c\\x0e-\\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\\x01-\\x08\\x0b\\x0c\\x0e-\\x1f\\x21-\\x5a\\x53-\\x7f]|\\\\[\\x01-\\x09\\x0b\\x0c\\x0e-\\x7f])+)\\])");
    }

    private boolean descriptionVerification(){
        return descriptionField.getText() != null;
    }



    public boolean apiCheck() throws IOException {

        String url = "https://entreprise.data.gouv.fr/api/rna/v1/id/"+numeroRNAField.getText();

        Connection.Response response = Jsoup.connect(url).ignoreContentType(true).ignoreHttpErrors(true).sslSocketFactory(socketFactory()).execute();

        if( response.statusCode() == 200 ){
            Document doc = response.parse();
            JSONObject json = new JSONObject(doc.getElementsByTag("body").first().text());
            JSONObject association = json.getJSONObject("association");
            String titre = association.getString("titre");

            return true;
        }
        else {
            return false;
        }
    }

    private SSLSocketFactory socketFactory() {
        TrustManager[] trustAllCerts = new TrustManager[]{new X509TrustManager() {
            public java.security.cert.X509Certificate[] getAcceptedIssuers() {
                return new X509Certificate[0];
            }

            public void checkClientTrusted(X509Certificate[] certs, String authType) {
            }

            public void checkServerTrusted(X509Certificate[] certs, String authType) {
            }
        }};

        try {
            SSLContext sslContext = SSLContext.getInstance("SSL");
            sslContext.init(null, trustAllCerts, new java.security.SecureRandom());

            return sslContext.getSocketFactory();
        } catch (NoSuchAlgorithmException | KeyManagementException e) {
            throw new RuntimeException("Failed to create a SSL socket factory", e);
        }
    }
}
