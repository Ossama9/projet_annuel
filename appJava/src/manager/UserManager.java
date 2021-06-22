package manager;

import persistence.User;

import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;

public class UserManager {

    private final Connection db = new DatabaseManager().getConnexion();


    public User getByUsername(String username) throws SQLException {
        User user = new User();

        String query = "SELECT id, username, password, first_name, last_name, email FROM user WHERE username = \"" + username +"\";";
        ResultSet rs = db.prepareStatement(query).executeQuery();

        if (!rs.isBeforeFirst() ) { System.out.println("No data"); }
        rs.next();
        user.feed(
            rs.getInt("id"),
            rs.getString("username"),
            rs.getString("password"),
            rs.getString("first_name"),
            rs.getString("last_name"),
            rs.getString("email")
        );

        return user;
    }

}
