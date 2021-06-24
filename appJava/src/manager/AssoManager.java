package manager;

import persistence.Asso;

import java.sql.PreparedStatement;
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

        PreparedStatement stmt = super.db.prepareStatement(query);
        stmt.setString(1, asso.getNumeroSiren() );
        stmt.setString(2, asso.getPassword());
        stmt.setString(3, asso.getName());
        stmt.setString(4, asso.getEmail());
        if(asso.getDescription() != null)
            stmt.setString(5, asso.getDescription());

        stmt.executeUpdate();
    }
}
