package controller.asso;

import controller.ControllerOne;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.PasswordField;
import javafx.scene.control.TextField;
import javafx.scene.text.Text;
import manager.AssoManager;
import persistence.Asso;

import java.sql.SQLException;

public class AssoConnexionController extends ControllerOne {

    @FXML
    public TextField rnaField;
    @FXML
    public PasswordField passwordField;
    @FXML
    public Text errorMsg;


    @FXML
    public void validConnection(ActionEvent event){
        if (rnaField.getText().isEmpty() && passwordField.getText().isEmpty()) {
            errorMsg.setText("identifiant ou mot de passe incorrect");
        }
        else{
            if (rnaField.getText().matches("^[0-9]{9}$") )
                rnaField.setText('W'+rnaField.getText());

            AssoManager assoManager = new AssoManager();
            try {
                Asso asso = assoManager.getAssoBySiren(rnaField.getText());

                ControllerAsso.loadAssoIndex(event, asso);
            }
            catch (SQLException e){
                e.printStackTrace();
            }
        }
    }
}
