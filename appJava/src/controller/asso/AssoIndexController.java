package controller.asso;

import controller.ShowProjectCell;
import javafx.beans.property.SimpleBooleanProperty;
import javafx.collections.ObservableList;
import javafx.fxml.FXML;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.text.Text;

import javafx.stage.Stage;
import manager.ProjectManager;
import persistence.Asso;
import persistence.Project;

import java.sql.SQLException;


public class AssoIndexController extends ControllerAsso {

    @FXML public Text successMsg;
    @FXML public Text validationMsg;
    @FXML public Text ongoingProjects;


    @FXML private TableView<Project> assoProjectsTable;
    @FXML private TableColumn<Project, String> nameColumn;
    @FXML private TableColumn<Project, String> descriptionColumn;
    @FXML private TableColumn<Project, Integer> coinsColumn;
    @FXML private TableColumn<Project, Boolean> buttonColumn;

    @Override
    public void initData(Asso asso) {
        super.initData(asso);

        ProjectManager projectManager = new ProjectManager();
        if( asso != null && asso.getStatus() != 0 ){

            ObservableList<Project> assoProjects;

            try {
                assoProjects = projectManager.getAssoProjects(asso.getId(), asso.getName());
                ongoingProjects.setText(String.valueOf(assoProjects.size()));

                assoProjectsTable.setItems(assoProjects);
                nameColumn.setCellValueFactory(new PropertyValueFactory<>("name"));
                descriptionColumn.setCellValueFactory(new PropertyValueFactory<>("description"));
                coinsColumn.setCellValueFactory(new PropertyValueFactory<>("coinsEarned"));

                // define a simple boolean cell value for the action column so that the column will only be shown for non-empty rows.
                buttonColumn.setCellValueFactory(features -> new SimpleBooleanProperty(features.getValue() != null));
                // create a cell value factory with an add button for each row in the table.
                buttonColumn.setCellFactory(projectBooleanTableColumn -> new ShowProjectCell((Stage) mainPane.getScene().getWindow(), assoProjectsTable, asso));
            }
             catch (SQLException e) {
                 e.printStackTrace();
             }
        }
        else
            ongoingProjects.setText("0");

        assert asso != null;
        if( asso.getStatus() == 0 )
            validationMsg.setText( "En attente de validation par un administrateur");
    }


}
