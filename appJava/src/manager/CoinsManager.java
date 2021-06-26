package manager;

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

    public int getProjectTotalCoins(int projectId) throws SQLException {
        String query = """
            SELECT COALESCE(SUM( user_project.amount ), 0) AS coins
            FROM user_project
            WHERE project_id =
             """ + projectId + ";";
        ResultSet rs = db.prepareStatement(query).executeQuery();

        rs.next();
        return rs.getInt("coins");
    }
}
