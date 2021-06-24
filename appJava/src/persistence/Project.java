package persistence;

import java.util.Date;
import java.util.Locale;

public class Project {

    private int id;
    private String name;
    private Date startDate;
    private Date endDate;
    private String description;
    private int assoId;
    private int coinsEarned;

    public Project(String name, Date startDate, Date endDate, String description, int assoId ) {
        this.name = name;
        this.startDate = startDate;
        this.endDate = endDate;
        this.description = description;
        this.assoId = assoId;
    }

    public Project(int id, String name, Date startDate, Date endDate, String description, int assoId ) {
        this.id = id;
        this.name = name;
        this.startDate = startDate;
        this.endDate = endDate;
        this.description = description;
        this.assoId = assoId;
    }


    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
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

    public int getCoinsEarned() {
        return coinsEarned;
    }

    public void setCoinsEarned(int coinsEarned) {
        this.coinsEarned = coinsEarned;
    }
}
