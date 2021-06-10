package controller;

import javafx.fxml.FXML;
import javafx.scene.control.Label;
import javafx.scene.control.PasswordField;
import javafx.scene.control.TextField;

import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.Statement;


public class ConnexionController {

    @FXML
    private TextField usernameText;

    @FXML
    private PasswordField passwordField;

    @FXML
//    private Label textLabel;


    public void valid(){
//        textLabel.setText("Connexion en cours");
        DatabaseConnection connection = new DatabaseConnection();
        Connection connDb = connection.getConnection();
        String req = "SELECT * FROM user WHERE username = '" + usernameText.getText() + "'";
//        String req2 =" AND password = '\" + passwordField.getText() + \"'";
        System.out.println(usernameText.getText().toString());
        try {
            Statement statement = connDb.createStatement();
            ResultSet queryResult = statement.executeQuery(req);


            while (queryResult.next()){
                if (queryResult.getInt(1) == 1){
                    System.out.println("GG");
                }
                else {
                    System.out.println("NN");

                }
            }

        }
        catch (Exception e){
            e.printStackTrace();
            e.getCause();
        }
    }
}
