package controller.admin;


import controller.ShowProjectCell;
import javafx.beans.property.SimpleBooleanProperty;
import javafx.collections.ObservableList;
import javafx.fxml.FXML;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.stage.Stage;
import manager.ProjectManager;
import persistence.Project;
import persistence.User;

import java.sql.SQLException;

public class AdminIndexController extends ControllerAdmin {

    @FXML private TableView<Project> newProjectsTable;
    @FXML private TableColumn<Project, String> associationColumn;
    @FXML private TableColumn<Project, String> projectNameColumn;
    @FXML private TableColumn<Project, String> projectDescriptionColumn;
    @FXML private TableColumn<Project, Boolean> projectButtonColumn;

    @Override
    public void initData(User admin){
        super.initData(admin);

        //projects tab
        ProjectManager projectManager = new ProjectManager();
        try {
            ObservableList<Project> newProject = projectManager.getProjectsToValidate();
            newProjectsTable.setItems(newProject);
            associationColumn.setCellValueFactory(new PropertyValueFactory<>("assoName"));
            projectNameColumn.setCellValueFactory(new PropertyValueFactory<>("name"));
            projectDescriptionColumn.setCellValueFactory(new PropertyValueFactory<>("description"));
            projectButtonColumn.setCellValueFactory(new PropertyValueFactory<>("coinsEarned"));

            //here because user need to be initilised
            // define a simple boolean cell value for the action column so that the column will only be shown for non-empty rows.
            projectButtonColumn.setCellValueFactory(features -> new SimpleBooleanProperty(features.getValue() != null));
            // create a cell value factory with an add button for each row in the table.
            projectButtonColumn.setCellFactory(projectBooleanTableColumn -> new ShowProjectCell((Stage) mainPane.getScene().getWindow(), newProjectsTable, admin));


        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }
    }
}
