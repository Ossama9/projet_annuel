package controller.admin;

import controller.ControllerOne;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.text.Text;
import javafx.scene.text.TextAlignment;
import manager.ProjectManager;
import persistence.Project;
import persistence.User;

import java.sql.SQLException;

public class AdminProjectController extends ControllerAdmin{

    private Project project;

    @FXML private Text title;
    @FXML private Text depositDate;
    @FXML private Text associationName;
    @FXML private Text startDate;
    @FXML private Text endDate;
    @FXML private Text description;

    public void initData(Project project, User user){

        if( project == null )
            goToLandingPage();
        else
            this.project = project;

        if( user != null )
            this.admin = user;
        else
            goToLandingPage();

        if( admin.getRoles() ==  0)
            goToLandingPage();

        assert project != null;
        title.setText(project.getName());
        title.setTextAlignment(TextAlignment.CENTER);

        depositDate.setText(project.getDepositDate().toLocalDate().toString());
        associationName.setText(project.getAssoName());
        startDate.setText(project.getStartDate().toLocalDate().toString());
        endDate.setText(project.getEndDate().toLocalDate().toString());
        description.setText(project.getDescription());

    }


    @FXML
    public void supprProject(ActionEvent event){
        ProjectManager projectManager = new ProjectManager();
        try {
            projectManager.deleteProject(project.getId());
            ControllerOne.loadAdminIndex(event, admin);
        } catch (SQLException throwable) {
            throwable.printStackTrace();
        }
    }

    @FXML
    public void validateProject(ActionEvent event){
        ProjectManager projectManager = new ProjectManager();
        try {
            projectManager.updateStatus(project.getId());
            ControllerOne.loadAdminIndex(event, admin);
        } catch (SQLException throwable) {
            throwable.printStackTrace();
        }
    }


}
