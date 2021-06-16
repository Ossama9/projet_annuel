package controller.asso;

import controller.DatabaseConnection;
import javafx.fxml.FXML;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;

import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.Statement;

public class InscriptionController {


    @FXML
    private Label registrationMessageLabel;

    @FXML
    private TextField nameField;

    @FXML
    private TextField emailField;


    public void registerButtonAction(){
        registrationMessageLabel.setText("Remplir les champs");
        register();
    }
    public void register(){
        String name ;
        String email;
        int user_id = 5;
        int status = 0;

        DatabaseConnection connection = new DatabaseConnection();
        Connection connDb = connection.getConnection();
        name = nameField.getText();
        email = emailField.getText();
        String req = "INSERT INTO asso(name, user_id, email_contact, status) VALUES('";
        String values = name + "','" + user_id + "','" + email + "','" + status + "')";
        String request = req + values;
        try {
            Statement statement = connDb.createStatement();
            statement.executeUpdate(request);
            registrationMessageLabel.setText("Votre demande est en cours de traitement");

        }
        catch (Exception e){
            e.printStackTrace();
            e.getCause();
        }
    }

}
