package controller.user;


import controller.ControllerOne;
import controller.ShowProjectCell;
import javafx.beans.property.SimpleBooleanProperty;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.Scene;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.stage.Stage;
import manager.ProjectManager;
import persistence.Project;
import persistence.User;

import java.io.IOException;
import java.net.URL;
import java.sql.SQLException;
import java.util.Objects;
import java.util.ResourceBundle;

public class UserIndexController extends ControllerUser implements Initializable {


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

        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }
    }


    @Override
    public void initData(User user){
        super.initData(user);

        //here because user need to be initilised
        // define a simple boolean cell value for the action column so that the column will only be shown for non-empty rows.
        buttonColumn.setCellValueFactory(features -> new SimpleBooleanProperty(features.getValue() != null));
        // create a cell value factory with an add button for each row in the table.
        buttonColumn.setCellFactory(projectBooleanTableColumn -> new ShowProjectCell((Stage) mainPane.getScene().getWindow(), newProjectsTable, user));
    }

    @FXML
    public void seeMyProjects(ActionEvent event){
        try {
            FXMLLoader loader = new FXMLLoader(Objects.requireNonNull(ControllerOne.class.getResource("/gui/user/user_projects.fxml")));
            Stage currentStage = (Stage)((Node) event.getSource()).getScene().getWindow();
            currentStage.setScene(new Scene(loader.load()));
            currentStage.setTitle(user.getUsername());

            UserProjectsController newController = loader.getController();
            newController.initData(user);

            currentStage.show();
        }
        catch (IOException e){
            System.out.println("Erreur de chargement: " + e);
        }
    }

}
