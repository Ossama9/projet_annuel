package persistence;


import java.sql.Date;

/**
 * password hash
 *  - method : BCrypt
 *  - salt : 10
 */
public class Asso {


    private int id;
    private int status;
    private String numeroSiren;
    private String name;
    private String password;
    private String email;
    private String description;
    private Date signupDate;
    private int ongoingProject;


    public Asso(){}


    public Asso(int status, String numeroSiren, String name, String email, String description, Date signUpDate) {
        this.status = status;
        this.numeroSiren = numeroSiren;
        this.name = name;
        this.email = email;
        this.description = description;
        this.signupDate = signUpDate;
    }

    public Asso(int id, int status, String numeroSiren, String password, String name, String email, String description, Date signUpDate) {
        this.id = id;
        this.status = status;
        this.numeroSiren = numeroSiren;
        this.password = password;
        this.name = name;
        this.email = email;
        this.description = description;
        this.signupDate = signUpDate;
    }



    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getStatus() {
        return status;
    }

    public void setStatus(int status) {
        this.status = status;
    }

    public String getNumeroSiren() {
        return numeroSiren;
    }

    public void setNumeroSiren(String numeroSiren) {
        this.numeroSiren = numeroSiren;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public Date getSignupDate() {
        return signupDate;
    }

    public void setSignupDate(Date signupDate) {
        this.signupDate = signupDate;
    }

    public int getOngoingProject() {
        return ongoingProject;
    }

    public void setOngoingProject(int ongoingProject) {
        this.ongoingProject = ongoingProject;
    }
}
