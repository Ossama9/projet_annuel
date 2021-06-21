package controller.users;

import manager.DatabaseManager;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Label;


import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ResourceBundle;


public class UserController implements Initializable {

    @FXML
    private Label emailLabel;

    @FXML
    private Label greencoinLabel;

    @FXML
    private Label usernameLabel;





    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {
    }
}
