package manager;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class CoinsManager extends Manager {

    public int getUserEarnedCoins(int userId) throws SQLException {
        String query = """
            SELECT COALESCE(SUM( product.price ), 0) AS coins
            FROM `order`
            INNER JOIN order_item ON order_item.order_ref_id = `order`.id
            INNER JOIN product ON product.id = order_item.product_id
            WHERE `order`.status = 1 AND `order`.ordered_by_id =
         """ + userId + ";";
        ResultSet rs = db.prepareStatement(query).executeQuery();

        rs.next();
        return rs.getInt("coins");
    }

    public int getUserUsedCoins(int userId) throws SQLException {
        String query = """
            SELECT COALESCE(SUM( user_project.amount ), 0) AS coins
            FROM user_project
            WHERE user_id =
             """ + userId + ";";
        ResultSet rs = db.prepareStatement(query).executeQuery();

        rs.next();
        return rs.getInt("coins");
    }

    public int getGivenCoins(int projectId, int userId) throws SQLException {
        String query = """
            SELECT COALESCE(SUM( user_project.amount ), 0) AS coins
            FROM user_project
            WHERE project_id = ? AND user_id = ?;
            """;
        PreparedStatement stmt = db.prepareStatement(query);
        stmt.setInt(1, projectId);
        stmt.setInt(2, userId);

        ResultSet rs = stmt.executeQuery();

        rs.next();
        return rs.getInt("coins");
    }

    public int allreadyDonate(int userId, int projectId) throws SQLException {

        String query = "SELECT id FROM user_project WHERE user_id = ? And project_id = ?;";
        PreparedStatement stmt = db.prepareStatement(query);
        stmt.setInt(1, userId);
        stmt.setInt(2, projectId);

        ResultSet rs = stmt.executeQuery();

        return rs.getRow();
    }

    public void createDonation(int userId, int projectId, int amount) throws SQLException {
        String query = "INSERT INTO user_project (user_id, project_id, amount) VALUES ( ?, ?, ?);";

        PreparedStatement stmt = db.prepareStatement(query);
        stmt.setInt(1, userId );
        stmt.setInt(2, projectId);
        stmt.setInt(3, amount);

        stmt.executeUpdate();
    }

    public void updateDonation(int userId, int projectId, int amount) throws SQLException{
        String query = "UPDATE user_project SET amount = (amount + ?) WHERE user_id = ? AND project_id = ?";
        PreparedStatement statement = db.prepareStatement(query);
        statement.setInt(1, amount);
        statement.setInt(2, userId);
        statement.setInt(3, projectId);

        statement.executeUpdate();
    }

    public int supprDonnation(int userId, int projectId) throws SQLException {
        String query = """
                DELETE FROM user_project
                WHERE project_id = ? AND user_id = ?;
                """;
        PreparedStatement stmt = db.prepareStatement(query);
        stmt.setInt(1, projectId);
        stmt.setInt(2, userId);

        return stmt.executeUpdate();
    }
}
