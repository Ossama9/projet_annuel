package manager;

import java.sql.Connection;

public abstract class Manager {

    protected final Connection db = new DatabaseManager().getConnexion();
}
