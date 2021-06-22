package manager;

import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;

public class CoinsManager {

    private final Connection db = new DatabaseManager().getConnexion();


    public int geUserCoins(int userId) throws SQLException {
        String query = """
                    SELECT SUM( product.price ) AS coins FROM `order`
                    INNER JOIN order_item ON order_item.order_ref_id = `order`.id
                    INNER JOIN product ON product.id = order_item.product_id
                    WHERE `order`.status = 1 AND `order`.ordered_by_id = 1;
                """;
        ResultSet rs = db.prepareStatement(query).executeQuery();

        if (!rs.isBeforeFirst()){
            System.out.println("No data");
            return 0;
        }
        else {
            rs.next();
            return rs.getInt("coins");
        }
    }
}
