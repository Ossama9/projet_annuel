package controller.asso;

import manager.DatabaseManager;
import javafx.collections.ObservableList;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Label;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.input.MouseEvent;
import persistence.Asso;

import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.util.ResourceBundle;

public class ListAsso implements Initializable {

    @FXML
    private Label id;

    @FXML
    private TableView<Asso> table_asso;

    @FXML
    private TableColumn<Asso, Integer> col_id;

    @FXML
    private TableColumn<Asso, String> col_name;

    @FXML
    private TableColumn<Asso, String> col_responsable;

    @FXML
    private TableColumn<Asso, String> col_contact;

    @FXML
    private TableColumn<Asso, Integer> col_status;



    ObservableList<Asso> listM;
    int index = -1;


    PreparedStatement pst = null;



    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {


        col_id.setCellValueFactory(new PropertyValueFactory<Asso, Integer>("id"));
        col_status.setCellValueFactory(new PropertyValueFactory<Asso, Integer>("status"));
        col_name.setCellValueFactory(new PropertyValueFactory<Asso, String>("name"));
        col_responsable.setCellValueFactory(new PropertyValueFactory<Asso, String>("users"));
        col_contact.setCellValueFactory(new PropertyValueFactory<Asso, String>("email_contact"));

        //listM = DatabaseManager.getasso();
        table_asso.setItems(listM);

    }

    @FXML
    void getSelected(MouseEvent event) {
        index = table_asso.getSelectionModel().getFocusedIndex();
        if (index <= -1){
            return;
        }
        System.out.println(col_id.getCellData(index).toString());
        id.setText(col_id.getCellData(index).toString());

    }

    public void Update(){
        Connection db = new DatabaseManager().getConnexion();
        String req = "UPDATE asso SET status = 1 WHERE id = ? ";
        try {
            pst = db.prepareStatement(req);
            pst.setString(1,id.getText());
            pst.execute();
        }
        catch (Exception e){

        }

    }

    public void Delete(){

    }


}
