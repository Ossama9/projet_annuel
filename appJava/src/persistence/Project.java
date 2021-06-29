package persistence;

import javafx.beans.property.SimpleStringProperty;
import javafx.beans.property.StringProperty;

import java.sql.Date;


public class Project {

    private int id;
    private String name;
    private Date depositDate;
    private Date startDate;
    private Date endDate;
    private String description;
    private int assoId;
    private String assoName;
    private int coinsEarned;

    public Project(String name, Date depositDate, Date startDate, Date endDate, String description, int assoId ) {
        this.name = name;
        this.depositDate = depositDate;
        this.startDate = startDate;
        this.endDate = endDate;
        this.description = description;
        this.assoId = assoId;
    }

    public Project(int id, String name, Date depositDate, Date startDate, Date endDate, String description, int assoId ) {
        this.id = id;
        this.name = name;
        this.depositDate = depositDate;
        this.startDate = startDate;
        this.endDate = endDate;
        this.description = description;
        this.assoId = assoId;
    }

    public Project(int id, String name, Date depositDate, Date startDate, Date endDate, String description, int assoId, String assoName, int coinsEarned ) {
        this.id = id;
        this.name = name;
        this.depositDate = depositDate;
        this.startDate = startDate;
        this.endDate = endDate;
        this.description = description;
        this.assoId = assoId;
        this.assoName = assoName;
        this.coinsEarned = coinsEarned;
    }


    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    private final StringProperty name2 = new SimpleStringProperty(this, "name");
    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public Date getDepositDate() {
        return depositDate;
    }

    public void setDepositDate(Date depositDate) {
        this.depositDate = depositDate;
    }

    public Date getStartDate() {
        return startDate;
    }

    public void setStartDate(Date startDate) {
        this.startDate = startDate;
    }

    public Date getEndDate() {
        return endDate;
    }

    public void setEndDate(Date endDate) {
        this.endDate = endDate;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public int getAssoId() {
        return assoId;
    }

    public void setAssoId(int assoId) {
        this.assoId = assoId;
    }

    public String getAssoName() {
        return assoName;
    }

    public void setAssoName(String assoName) {
        this.assoName = assoName;
    }

    public int getCoinsEarned() {
        return coinsEarned;
    }

    public void setCoinsEarned(int coinsEarned) {
        this.coinsEarned = coinsEarned;
    }
}
