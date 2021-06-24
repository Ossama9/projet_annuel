package persistence;

public class Asso {


    private int id, status;
    private String name, password, email, description, numeroSiren;

    public Asso(){}

    public Asso(int status, String numeroSiren, String name, String email) {
        this.status = status;
        this.numeroSiren = numeroSiren;
        this.name = name;
        this.email = email;
    }

    public Asso(int status, String numeroSiren, String name, String email, String description) {
        this.status = status;
        this.numeroSiren = numeroSiren;
        this.name = name;
        this.email = email;
        this.description = description;
    }

    public Asso(int id, int status, String numeroSiren, String password, String name, String email, String description) {
        this.id = id;
        this.status = status;
        this.numeroSiren = numeroSiren;
        this.password = password;
        this.name = name;
        this.email = email;
        this.description = description;
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
}
