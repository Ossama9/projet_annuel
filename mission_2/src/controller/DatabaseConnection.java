package controller;

import controller.asso.Asso;
import controller.projet.Projet;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;

import java.sql.*;

import static javafx.collections.FXCollections.*;

public class DatabaseConnection {
    public Connection database;
    public Connection getConnection() {
        try {

            String myUrl = "jdbc:mysql://localhost:3306/ready_to_use";
            database = DriverManager.getConnection(myUrl, "root", "root");

        }
        catch (Exception e){
            e.printStackTrace();
        }
        return database;
    }

    public static ObservableList<Asso> getasso(){


        ObservableList<Asso> list = FXCollections.<Asso>observableArrayList();

        try {
            String myUrl = "jdbc:mysql://localhost:3306/ready_to_use";
            Connection connDb = DriverManager.getConnection(myUrl, "root", "root");

            PreparedStatement ps = connDb.prepareStatement("SELECT * FROM asso ");
            ResultSet rs = ps.executeQuery();
            while (rs.next()){
                PreparedStatement ps_name = connDb.prepareStatement("SELECT username FROM user INNER JOIN asso ON asso.user_id = user.id WHERE user_id = '"+ rs.getString("user_id") +"' AND asso.id = '"+rs.getString("id") +"'");
                ResultSet rs_name = ps_name.executeQuery();
                while (rs_name.next()){

                    list.add(new Asso(Integer.parseInt(rs.getString("id")), Integer.parseInt(rs.getString("status")) , rs_name.getString("username"), rs.getString("nameAsso"),rs.getString("email_contact") ));

                }
            }
        }
        catch (Exception e){
            e.getCause();
            e.printStackTrace();
        }
        return list;
    }

    public static ObservableList<Projet> getProjet(){

        ObservableList<Projet> list = FXCollections.<Projet>observableArrayList();

        try {
            String myUrl = "jdbc:mysql://localhost:3306/ready_to_use";
            Connection connDb = DriverManager.getConnection(myUrl, "root", "root");

            PreparedStatement ps = connDb.prepareStatement("SELECT * FROM projet ");
            ResultSet rs = ps.executeQuery();
            while (rs.next()){

                PreparedStatement ps_name = connDb.prepareStatement("SELECT nameAsso FROM asso INNER JOIN projet ON asso.id = projet.id_asso WHERE id_asso = '"+ rs.getString("id_asso") +"' AND projet.id = '"+rs.getString("id") +"'");
                ResultSet rs_name = ps_name.executeQuery();

                while (rs_name.next()){
                    list.add(new Projet(Integer.parseInt(rs.getString("id")), Integer.parseInt(rs.getString("tarif")), rs.getString("nameProjet"), rs.getString("descriptif"), rs_name.getString("nameAsso")));
                }
            }
        }
        catch (Exception e){
            e.getCause();
            e.printStackTrace();
        }
        return list;
    }

}

