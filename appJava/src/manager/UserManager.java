package manager;

import persistence.User;


import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;



public class UserManager extends Manager{

    public User getByUsername(String username) throws SQLException {
        User user = new User();

        String query = "SELECT id, username, password, first_name, last_name, email FROM user WHERE username = \"" + username +"\";";
        ResultSet rs = super.db.prepareStatement(query).executeQuery();

        if (!rs.isBeforeFirst() )
            return new User();
        else{
            rs.next();
            user = new User(
                    rs.getInt("id"),
                    rs.getString("username"),
                    rs.getString("password"),
                    rs.getString("first_name"),
                    rs.getString("last_name"),
                    rs.getString("email")
            );
        }

        return user;
    }

    public int getUserProjects(int userId) throws SQLException {
        String query = """
                SELECT COALESCE(SUM( user_project.id ), 0) AS projects 
                FROM user_project 
                WHERE user_project.id = ? ;
                """;
        PreparedStatement statement = db.prepareStatement(query);
        statement.setInt(1,userId);
        ResultSet rs = statement.executeQuery();
        rs.next();
        return rs.getInt("projects");
    }

}
