package manager;

import javafx.beans.value.ObservableValue;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import persistence.Asso;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class AssoManager extends Manager{


    public void insertAsso(Asso asso) throws SQLException {
        String query = "INSERT INTO association (numero_rna, password, name, email, signup_date, status, description ) VALUES (?, ?, ?, ?, ?, 0, ?); ";

        PreparedStatement stmt = db.prepareStatement(query);
        stmt.setString(1, asso.getNumeroRNA() );
        stmt.setString(2, asso.getPassword());
        stmt.setString(3, asso.getName());
        stmt.setString(4, asso.getEmail());
        stmt.setDate(5, asso.getSignupDate());
        stmt.setString(6, asso.getDescription());

        stmt.executeUpdate();
    }


    public void updateStatus(int assoId) throws SQLException {
        String query = """
                UPDATE association
                SET status = 1
                WHERE id = ?
                """;
        PreparedStatement statement = db.prepareStatement(query);
        statement.setInt(1, assoId);
        System.out.println(statement);
        statement.executeUpdate();
    }


    public void deleteAsso(int assoId) throws SQLException {
        String query = """
                DELETE FROM association
                WHERE id = ?
                """;
        PreparedStatement statement = db.prepareStatement(query);
        statement.setInt(1, assoId);
        statement.executeUpdate();
    }


    public Asso getAssoBySiren(String numeroRNA) throws SQLException {


        String query = "SELECT * FROM association WHERE numero_rna = ? ;";
        PreparedStatement stmt = db.prepareStatement(query);
        stmt.setString(1, numeroRNA);

        ResultSet rs = stmt.executeQuery();

        if (!rs.isBeforeFirst() ) {
            return new Asso();
        }
        else{
            rs.next();
            return new Asso(
                    rs.getInt("id"),
                    rs.getInt("status"),
                    rs.getString("numero_rna"),
                    rs.getString("password"),
                    rs.getString("name"),
                    rs.getString("email"),
                    rs.getString("description"),
                    rs.getDate("signup_date")
            );
        }
    }


    public ObservableList<Asso> getAssoToValidate() throws SQLException {
        ObservableList<Asso> list = FXCollections.observableArrayList();

        String query = """
                SELECT id, name,description, numero_rna, email, signup_date
                FROM association
                WHERE status = 0
                """;
        ResultSet rs = db.prepareStatement(query).executeQuery();

        while (rs.next()){
            list.add(
              new Asso(
                      rs.getString("numero_rna"),
                      rs.getInt("id"),
                      rs.getString("name"),
                      rs.getString("email"),
                      rs.getString("description"),
                      rs.getDate("signup_date")
              )
            );
        }

        return list;
    }
}












