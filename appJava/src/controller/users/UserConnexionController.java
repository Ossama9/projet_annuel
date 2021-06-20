package controller.users;

import javafx.event.ActionEvent;
import javafx.scene.control.Button;
import javafx.fxml.FXML;

import javafx.scene.control.PasswordField;
import javafx.scene.control.TextField;
import javafx.scene.text.Text;
import manager.UserManager;
import org.mindrot.jbcrypt.BCrypt;
import persistence.User;

import java.sql.SQLException;

public class UserConnexionController {

    @FXML
    private TextField usernameField;
    @FXML
    private PasswordField passwordField;
    @FXML
    private Button btnLogin;
    @FXML
    private Text errorMsg;

    @FXML
    private void valid(ActionEvent event){

        if (usernameField.getText().isEmpty() && passwordField.getText().isEmpty()) {
            errorMsg.setText("identifiant ou mot de passe incorrect");
        }
        else{
            try{
                UserManager userManager = new UserManager();
                User user  = userManager.getByUsername(usernameField.getText());
                if( BCrypt.checkpw(passwordField.getText(), user.getPassword()) ){
                    System.out.println("ok");
                }
                else {
                    errorMsg.setText("identifiant ou mot de passe incorrect");
                }
            } catch (SQLException e) {
                System.out.println(e.getMessage());
            }
        }
    }
}
