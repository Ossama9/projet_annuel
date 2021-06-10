package controller.asso;

public class Asso {


    Integer id, status;
    String  users;
    String name, email_contact;

    public Asso(Integer id, Integer status, String users, String name, String email_contact) {
        this.id = id;
        this.status = status;
        this.users = users;
        this.name = name;
        this.email_contact = email_contact;
    }

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public Integer getStatus() {
        return status;
    }

    public void setStatus(Integer status) {
        this.status = status;
    }

    public String getUsers() {
        return users;
    }

    public void setUsers(String users) {
        this.users = users;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getEmail_contact() {
        return email_contact;
    }

    public void setEmail_contact(String email_contact) {
        this.email_contact = email_contact;
    }
}
