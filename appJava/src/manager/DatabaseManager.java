package manager;

import persistence.Project;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;

import java.sql.*;

public class DatabaseManager {

    //"jdbc:mysql://localhost:3306/ready_to_use""jdbc:mysql://37.187.180.112:3306/ready_to_use"
    private static final String URL = "jdbc:mysql://localhost:3306/ready_to_use" ;
    private static final String USER = "root";
    private static final String PASSWORD = "root";

    private Connection connexion;

    public DatabaseManager() {
        try {
            connexion = DriverManager.getConnection(URL, USER, PASSWORD);
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public Connection getConnexion() {
        return connexion;
    }


}

