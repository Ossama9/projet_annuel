package controller.user;

import controller.ShowProjectCell;
import javafx.beans.property.SimpleBooleanProperty;
import javafx.collections.ObservableList;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.stage.Stage;
import manager.ProjectManager;
import persistence.Project;
import persistence.User;

import java.sql.SQLException;

public class UserProjectsController extends ControllerUser {

    @FXML private TableView<Project> myProjectsTable;
    @FXML private TableColumn<Project, String> associationColumn;
    @FXML private TableColumn<Project, String> nameColumn;
    @FXML private TableColumn<Project, String> descriptionColumn;
    @FXML private TableColumn<Project, Integer> coinsColumn;
    @FXML private TableColumn<Project, Boolean> buttonColumn;


    @Override
    public void initData(User user){
        super.initData(user);

        ProjectManager projectManager = new ProjectManager();
        try {
            ObservableList<Project> myProject = projectManager.getUserProjects(user.getId());
            myProjectsTable.setItems(myProject);
            associationColumn.setCellValueFactory(new PropertyValueFactory<>("assoName"));
            nameColumn.setCellValueFactory(new PropertyValueFactory<>("name"));
            descriptionColumn.setCellValueFactory(new PropertyValueFactory<>("description"));
            coinsColumn.setCellValueFactory(new PropertyValueFactory<>("coinsEarned"));

        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }

        //here because user need to be initilised
        // define a simple boolean cell value for the action column so that the column will only be shown for non-empty rows.
        buttonColumn.setCellValueFactory(features -> new SimpleBooleanProperty(features.getValue() != null));
        // create a cell value factory with an add button for each row in the table.
        buttonColumn.setCellFactory(projectBooleanTableColumn -> new ShowProjectCell((Stage) mainPane.getScene().getWindow(), myProjectsTable, user));
    }
}
