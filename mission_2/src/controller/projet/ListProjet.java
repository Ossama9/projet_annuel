package controller.projet;

import controller.DatabaseConnection;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.input.MouseEvent;

import java.net.URL;
import java.util.ResourceBundle;

public class ListProjet implements Initializable {

    @FXML
    private TableView<Projet> table_projet;

    @FXML
    private TableColumn<Projet, Integer> col_id;

    @FXML
    private TableColumn<Projet, String> col_name;

    @FXML
    private TableColumn<Projet, Integer> col_tarif;

    @FXML
    private TableColumn<Projet, String> col_association;

    @FXML
    private TableColumn<Projet, String> col_descriptif;

    ObservableList<Projet> listM;
    int index = -1;

    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {


        col_id.setCellValueFactory(new PropertyValueFactory<Projet, Integer>("id"));
        col_name.setCellValueFactory(new PropertyValueFactory<Projet, String>("name"));
        col_tarif.setCellValueFactory(new PropertyValueFactory<Projet, Integer>("tarif"));
        col_association.setCellValueFactory(new PropertyValueFactory<Projet, String>("asso_name"));
        col_descriptif.setCellValueFactory(new PropertyValueFactory<Projet, String>("descriptif"));

        listM = DatabaseConnection.getProjet();
        table_projet.setItems(listM);


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
