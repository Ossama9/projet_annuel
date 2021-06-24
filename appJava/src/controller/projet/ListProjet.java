package controller.projet;

import manager.DatabaseManager;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.input.MouseEvent;
import persistence.Project;

import java.net.URL;
import java.util.ResourceBundle;

public class ListProjet implements Initializable {

    @FXML
    private TableView<Project> table_projet;

    @FXML
    private TableColumn<Project, Integer> col_id;

    @FXML
    private TableColumn<Project, String> col_name;

    @FXML
    private TableColumn<Project, Integer> col_tarif;

    @FXML
    private TableColumn<Project, String> col_association;

    @FXML
    private TableColumn<Project, String> col_descriptif;

    ObservableList<Project> listM;
    int index = -1;

    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {


        col_id.setCellValueFactory(new PropertyValueFactory<Project, Integer>("id"));
        col_name.setCellValueFactory(new PropertyValueFactory<Project, String>("name"));
        col_tarif.setCellValueFactory(new PropertyValueFactory<Project, Integer>("tarif"));
        col_association.setCellValueFactory(new PropertyValueFactory<Project, String>("asso_name"));
        col_descriptif.setCellValueFactory(new PropertyValueFactory<Project, String>("descriptif"));

        //listM = DatabaseManager.getProjet();
        //table_projet.setItems(listM);


    }

    @FXML
    void desinscrire(ActionEvent event) {

    }

    @FXML
    void getSelected(MouseEvent event) {

    }

    @FXML
    void sinscrire(ActionEvent event) {

    }

}
