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
    public TextField sirenField;
    @FXML
    public PasswordField passwordField;
    @FXML
    public Text errorMsg;


    @FXML
    public void validConnection(ActionEvent event){
        if (sirenField.getText().isEmpty() && passwordField.getText().isEmpty()) {
            errorMsg.setText("identifiant ou mot de passe incorrect");
        }
        else{
            AssoManager assoManager = new AssoManager();
            try {
                Asso asso = assoManager.getAssoBySiren(sirenField.getText());

                ControllerOne.goToAssoIndex(event, asso);
            }
            catch (SQLException e){
                e.printStackTrace();
            }
        }
    }


}
