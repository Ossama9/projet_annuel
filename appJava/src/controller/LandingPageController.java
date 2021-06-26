package controller;


import javafx.beans.property.SimpleBooleanProperty;
import javafx.beans.value.ObservableValue;
import javafx.collections.ObservableList;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.TableCell;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.stage.Stage;
import javafx.util.Callback;
import manager.ProjectManager;
import persistence.Project;

import java.net.URL;
import java.sql.SQLException;
import java.util.ResourceBundle;

public class LandingPageController extends ControllerOne implements Initializable {


    @FXML private TableView<Project> newProjectsTable;
    @FXML private TableColumn<Project, String> associationColumn;
    @FXML private TableColumn<Project, String> nameColumn;
    @FXML private TableColumn<Project, String> descriptionColumn;
    @FXML private TableColumn<Project, Integer> coinsColumn;
    @FXML private TableColumn<Project, Boolean> buttonColumn;


    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {
        ProjectManager projectManager = new ProjectManager();
        try {
            ObservableList<Project> newProject = projectManager.getRecentsProjects();
            newProjectsTable.setItems(newProject);
            associationColumn.setCellValueFactory(new PropertyValueFactory<>("assoName"));
            nameColumn.setCellValueFactory(new PropertyValueFactory<>("name"));
            descriptionColumn.setCellValueFactory(new PropertyValueFactory<>("description"));
            coinsColumn.setCellValueFactory(new PropertyValueFactory<>("coinsEarned"));

            // define a simple boolean cell value for the action column so that the column will only be shown for non-empty rows.
            buttonColumn.setCellValueFactory(features -> new SimpleBooleanProperty(features.getValue() != null));
            // create a cell value factory with an add button for each row in the table.
            buttonColumn.setCellFactory(projectBooleanTableColumn -> new ShowProjectCell((Stage) mainPane.getScene().getWindow(), newProjectsTable));


        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }
    }
}
