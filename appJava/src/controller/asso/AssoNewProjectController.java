package controller.asso;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.TextField;
import javafx.scene.control.DatePicker;
import javafx.scene.control.TextArea;
import javafx.scene.text.Text;

import manager.ProjectManager;
import persistence.Project;

import java.sql.Date;
import java.sql.SQLException;
import java.time.LocalDate;
import java.time.ZoneId;


public class AssoNewProjectController extends ControllerAsso {

    @FXML
    public TextField nameField;
    @FXML
    public DatePicker startDateField;
    @FXML
    public DatePicker endDateField;
    @FXML
    public TextArea descriptionField;
    @FXML
    public Text errorMsg;


    @FXML
    public void validProject(ActionEvent event){

        if( nameFielVerification()
            && dateVerification()
            && descriptionVerification()
        ){
            Project project = new Project(
                nameField.getText(),
                Date.from(startDateField.getValue().atStartOfDay(ZoneId.systemDefault()).toInstant() ),
                Date.from(endDateField.getValue().atStartOfDay(ZoneId.systemDefault()).toInstant() ),
                descriptionField.getText(),
                asso.getId()
            );
            ProjectManager projectManager = new ProjectManager();
            try {
                projectManager.insertProject(project);
                loadAssoIndex(event, asso, "Nouveaux projet ajouté");
            }
            catch (SQLException e){
                e.printStackTrace();
            }
        }
        else {
            errorMsg.setText("champs invalide");
        }

    }

    public boolean nameFielVerification(){
        return nameField.getText() != null;
    }

    public boolean dateVerification() {

        if (startDateField.getValue() == null || endDateField.getValue() == null)
            return false;
        else {
            System.out.println(LocalDate.now());
            System.out.println(LocalDate.now().compareTo(endDateField.getValue()));
            return endDateField.getValue().compareTo(startDateField.getValue()) > 0
                    && endDateField.getValue().compareTo(LocalDate.now()) >= 0;
        }
    }

    public boolean descriptionVerification(){
        return descriptionField.getText() != null;
    }
}
