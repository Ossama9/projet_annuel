package manager;

import persistence.Project;

import java.sql.Date;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.time.ZoneId;

public class ProjectManager extends Manager{


    public void insertProject(Project project) throws SQLException {
        String query = "INSERT INTO project (name, start_date, end_date, description, association_id) VALUES (?, ?, ?, ?, ?);";

        PreparedStatement stmt = db.prepareStatement(query);
        stmt.setString(1, project.getName());
        stmt.setDate(2, Date.valueOf( project.getStartDate().toInstant().atZone(ZoneId.systemDefault()).toLocalDate()));
        stmt.setDate(3, Date.valueOf( project.getEndDate().toInstant().atZone(ZoneId.systemDefault()).toLocalDate()));
        stmt.setString(4, project.getDescription());
        stmt.setInt(5, project.getAssoId());

        stmt.executeUpdate();
    }
}
