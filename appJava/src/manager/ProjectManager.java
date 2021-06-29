package manager;

import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import persistence.Project;

import java.sql.Date;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.time.LocalDate;

public class ProjectManager extends Manager{


    public void insertProject(Project project) throws SQLException {
        String query = "INSERT INTO project (name, deposit_date, start_date, end_date, description, association_id, status) VALUES (?, ?, ?, ?, ?, ?, 0);";

        PreparedStatement stmt = db.prepareStatement(query);
        stmt.setString(1, project.getName());
        stmt.setDate(2, project.getDepositDate());
        stmt.setDate(3, project.getStartDate());
        stmt.setDate(4, project.getEndDate());
        stmt.setString(5, project.getDescription());
        stmt.setInt(6, project.getAssoId());

        stmt.executeUpdate();
    }


    public void updateStartDate(LocalDate date, int projectId) throws SQLException {
        String query = """
                UPDATE project
                SET start_date = ?
                WHERE id = ?
                """;
        PreparedStatement statement = db.prepareStatement(query);
        statement.setDate(1, Date.valueOf(date));
        statement.setInt(2, projectId);

        statement.executeUpdate();
    }

    public void updateEndDate(LocalDate date, int projectId) throws SQLException {
        String query = """
                UPDATE project
                SET end_date = ?
                WHERE id = ?
                """;
        PreparedStatement statement = db.prepareStatement(query);
        statement.setDate(1, Date.valueOf(date));
        statement.setInt(2, projectId);

        statement.executeUpdate();
    }

    public void updateDescription(String description, int projectId) throws SQLException {
        String query = """
                UPDATE project
                SET description = ?
                WHERE id = ?
                """;
        PreparedStatement statement = db.prepareStatement(query);
        statement.setString(1, description);
        statement.setInt(2, projectId);

        statement.executeUpdate();
    }


    public ObservableList<Project> getAssoProjects(int assoId, String assoName) throws SQLException {
        ObservableList<Project> list = FXCollections.observableArrayList();

        String query = """
        SELECT project.id, project.name, project.deposit_date, project.start_date, project.end_date, project.description, project.status, COALESCE(SUM( user_project.amount ), 0) AS coins
        FROM project
        INNER JOIN user_project ON user_project.project_id = project.id
        WHERE association_id = ?
        GROUP BY project.id
        """;
        PreparedStatement statement = db.prepareStatement(query);
        statement.setInt(1, assoId);
        ResultSet rs = statement.executeQuery();

        while ( rs.next() ){
            list.add( new Project(
                    rs.getInt("id"  ),
                    rs.getString("name"),
                    rs.getInt("status"),
                    rs.getDate("deposit_date"),
                    rs.getDate("start_date"),
                    rs.getDate("end_date"),
                    rs.getString("description"),
                    assoId,
                    assoName,
                    rs.getInt("coins")
            ));
        }
        return list;
    }

    public ObservableList<Project> getUserProjects(int userId) throws SQLException {
        ObservableList<Project> list = FXCollections.observableArrayList();

        String query = """
                SELECT project.id, project.name, project.deposit_date, project.start_date, project.end_date, project.description, project.association_id, project.status, association.name AS association_name,\s
                COALESCE(SUM( user_project.amount ), 0) AS coins
                FROM user_project t
                INNER JOIN project ON project.id = t.project_id
                INNER JOIN association ON association.id = project.association_id
                LEFT JOIN user_project ON user_project.project_id = project.id
                WHERE t.user_id = ?
                GROUP BY t.id
                """;
        PreparedStatement statement = db.prepareStatement(query);
        statement.setInt(1, userId);
        ResultSet rs = statement.executeQuery();

        while ( rs.next() ){
            list.add( new Project(
                    rs.getInt("id"  ),
                    rs.getString("name"),
                    rs.getInt("status"),
                    rs.getDate("deposit_date"),
                    rs.getDate("start_date"),
                    rs.getDate("end_date"),
                    rs.getString("description"),
                    rs.getInt("association_id"),
                    rs.getString("association_name"),
                    rs.getInt("coins")
            ));
        }
        return list;
    }

    public ObservableList<Project> getRecentsProjects() throws SQLException {
        ObservableList<Project> list = FXCollections.observableArrayList();

        String query = """
                SELECT project.id, project.name, project.deposit_date, project.start_date, project.end_date, project.description, project.association_id, project.status, association.name AS association_name, COALESCE(SUM( user_project.amount ), 0) AS coins
                FROM project
                INNER JOIN association ON association.id = project.association_id
                LEFT JOIN user_project ON user_project.project_id = project.id
                GROUP BY project.id
                ORDER BY deposit_date
                LIMIT 50;
                """;
        ResultSet rs = db.prepareStatement(query).executeQuery();

        while ( rs.next() ){
            list.add( new Project(
                    rs.getInt("id"  ),
                    rs.getString("name"),
                    rs.getInt("status"),
                    rs.getDate("deposit_date"),
                    rs.getDate("start_date"),
                    rs.getDate("end_date"),
                    rs.getString("description"),
                    rs.getInt("association_id"),
                    rs.getString("association_name"),
                    rs.getInt("coins")

            ));
        }
        return list;
    }

    public ObservableList<Project> getProjectsToValidate() throws SQLException {
        ObservableList<Project> list = FXCollections.observableArrayList();

        String query = """
                SELECT project.id, project.name, project.deposit_date, project.start_date, project.end_date, project.description, project.association_id, project.status, association.name AS association_name
                FROM project
                INNER JOIN association ON association.id = project.association_id
                WHERE project.status = 0
                """;
        ResultSet rs = db.prepareStatement(query).executeQuery();

        while ( rs.next() ){
            list.add( new Project(
                    rs.getInt("id"  ),
                    rs.getString("name"),
                    rs.getInt("status"),
                    rs.getDate("deposit_date"),
                    rs.getDate("start_date"),
                    rs.getDate("end_date"),
                    rs.getString("description"),
                    rs.getInt("association_id"),
                    rs.getString("association_name")

            ));
        }
        return list;
    }
}