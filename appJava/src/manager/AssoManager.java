package manager;

import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import persistence.Asso;
import persistence.Project;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class AssoManager extends Manager{


    public void insertAsso(Asso asso) throws SQLException {
        String query;

        if( asso.getDescription() == null){
            query = "INSERT INTO association (numero_siren, password, name, email, status) VALUES (?, ?, ?, ?, 0); ";
        }
        else{
            query = "INSERT INTO association (numero_siren, password, name, email, status, description) VALUES (?, ?, ?, ?,0, ?); ";
        }

        PreparedStatement stmt = db.prepareStatement(query);
        stmt.setString(1, asso.getNumeroSiren() );
        stmt.setString(2, asso.getPassword());
        stmt.setString(3, asso.getName());
        stmt.setString(4, asso.getEmail());
        if(asso.getDescription() != null)
            stmt.setString(5, asso.getDescription());

        stmt.executeUpdate();
    }


    public Asso getAssoBySiren(String numeroSiren) throws SQLException {


        String query = "SELECT * FROM association WHERE numero_siren = ? ;";
        PreparedStatement stmt = db.prepareStatement(query);
        stmt.setString(1, numeroSiren);

        ResultSet rs = stmt.executeQuery();

        if (!rs.isBeforeFirst() ) {
            return new Asso();
        }
        else{
            rs.next();
            return new Asso(
                    rs.getInt("id"),
                    rs.getInt("status"),
                    rs.getString("numero_siren"),
                    rs.getString("password"),
                    rs.getString("name"),
                    rs.getString("email"),
                    rs.getString("description")
            );
        }
    }


    public ObservableList<Project> getOngoingProject(int assoId) throws SQLException {
        ObservableList<Project> list = FXCollections.<Project>observableArrayList();

        String query = "SELECT id, name, start_date, end_date, description, association_id FROM project WHERE association_id = " + assoId + ";";
        ResultSet rs = db.prepareStatement(query).executeQuery();

        while ( rs.next() ){
            list.add( new Project(
                rs.getInt("id"  ),
                rs.getString("name"),
                rs.getDate("start_date"),
                rs.getDate("end_date"),
                rs.getString("description"),
                rs.getInt("association_id")
            ));
        }
        return list;
    }
}