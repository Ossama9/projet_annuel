package controller.uers;

import controller.DatabaseConnection;
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
        PreparedStatement pst = null;

        try {
            DatabaseConnection connection = new DatabaseConnection();
            Connection connDb = connection.getConnection();
            PreparedStatement ps = connDb.prepareStatement("SELECT * FROM user WHERE id = 5");
            ResultSet rs = ps.executeQuery();
            while (rs.next()){


                usernameLabel.setText(rs.getString("username"));
                emailLabel.setText(rs.getString("email"));
                greencoinLabel.setText(rs.getString("roles"));

            }
        }
        catch (Exception e){
            e.getCause();
            e.printStackTrace();
        }

    }




}
