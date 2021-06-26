package controller.asso;

import controller.ControllerOne;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.TextArea;
import javafx.scene.control.TextField;
import javafx.scene.text.Text;
import persistence.Asso;

import java.sql.Date;
import java.util.Calendar;

public class AssoInscriptionController extends ControllerOne {


    @FXML private TextField nameField;
    @FXML private TextField numeroSirenField;
    @FXML private TextField emailField;
    @FXML private TextArea descriptionField;
    @FXML private Text errorMsg;


    @FXML
    public void validAssoInscription(ActionEvent event){

        if( nameVerification()
            && numeroSirenVerification()
            && emailVerification()
            && descriptionVerification()
        ){
            Asso asso = new Asso(
                    0,
                    numeroSirenField.getText(),
                    nameField.getText(),
                    emailField.getText(),
                    descriptionField.getText(),
                    new java.sql.Date(new java.util.Date().getTime())
            );
            ControllerAsso.loadAssoPaswordChoice(event, asso);
        }
        else {
            errorMsg.setText("Champs incorrect");
        }
    }


    private boolean nameVerification(){
        return nameField.getText() != null && nameField.getText().length() <= 50;
    }

    private  boolean numeroSirenVerification(){
        return  numeroSirenField.getText().matches("^[0-9]{9}$");
    }

    // RFC 5322 Official Standard
    private boolean emailVerification(){
        return emailField.getText().matches("(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|\"(?:[\\x01-\\x08\\x0b\\x0c\\x0e-\\x1f\\x21\\x23-\\x5b\\x5d-\\x7f]|\\\\[\\x01-\\x09\\x0b\\x0c\\x0e-\\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\\x01-\\x08\\x0b\\x0c\\x0e-\\x1f\\x21-\\x5a\\x53-\\x7f]|\\\\[\\x01-\\x09\\x0b\\x0c\\x0e-\\x7f])+)\\])");
    }

    private boolean descriptionVerification(){
        return descriptionField.getText() != null;
    }
}
