package controller.user;

import controller.ControllerOne;
import javafx.event.ActionEvent;
import javafx.fxml.FXMLLoader;
import javafx.scene.Node;
import javafx.scene.Scene;
import javafx.fxml.FXML;

import javafx.scene.control.PasswordField;
import javafx.scene.control.TextField;
import javafx.scene.text.Text;
import javafx.stage.Stage;
import manager.CoinsManager;
import manager.UserManager;
import org.mindrot.jbcrypt.BCrypt;
import persistence.User;

import java.io.IOException;
import java.sql.SQLException;
import java.util.Objects;

public class UserConnexionController extends ControllerOne {

    @FXML
    private TextField usernameField;
    @FXML
    private PasswordField passwordField;
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

                CoinsManager coinsManager = new CoinsManager();
                user.setEarnedCoins(coinsManager.getUserEarnedCoins(user.getId()));
                user.setUsedCoins(coinsManager.getUserUsedCoins(user.getId()));

                if( BCrypt.checkpw(passwordField.getText(), user.getPassword()) ){
                    ControllerOne.goToUserIndex(event, user);
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
