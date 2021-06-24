package controller.asso;

import controller.ControllerOne;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.TextField;
import javafx.scene.text.Text;

import manager.AssoManager;
import org.mindrot.jbcrypt.BCrypt;

import java.sql.SQLException;


public class AssoPasswordChoiceController extends ControllerAsso {

    @FXML
    private TextField password1Field;
    @FXML
    private TextField password2Field;
    @FXML
    private Text errorMsg;

    @FXML
    public void validPassword(ActionEvent event){
        String password = password1Field.getText();

        if( password != null && password.equals(password2Field.getText()) ){
            password = BCrypt.hashpw(password, BCrypt.gensalt());
            asso.setPassword(password);
            AssoManager assoManager = new AssoManager();

            try {
                assoManager.insertAsso(asso);
            } catch (SQLException throwable) {
                throwable.printStackTrace();
            }
            ControllerOne.goToAssoIndex(event, asso, "Votre association à bien été enregistré");
        }
        else {
            errorMsg.setText("Les mots de passe sont différents");
        }
    }
}
