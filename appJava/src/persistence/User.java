package persistence;

public class User {

    private int id;
    private String username;
    private String password;
    private String firstName;
    private String lastName;
    private String email;
    private int roles;
    private int earnedCoins;
    private int usedCoins;
    private int projects;

    public User(){}

    public User(int id, String username, String password, String firstName, String lastName, String email, int roles) {
        this.id = id;
        this.username = username;

        if( password.charAt(2) == 'y'){
            password = password.substring(0,2) + 'a' + password.substring(3, password.length());
        }
        this.password = password;

        this.firstName = firstName;
        this.lastName = lastName;
        this.email = email;
        this.roles = roles;
    }


    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getFirstName() {
        return firstName;
    }

    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }

    public String getLastName() {
        return lastName;
    }

    public void setLastName(String lastName) {
        this.lastName = lastName;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public int getEarnedCoins() {
        return earnedCoins;
    }

    public int getRoles() {
        return roles;
    }

    public void setRoles(int roles) {
        this.roles = roles;
    }

    public void setEarnedCoins(int earnedCoins) {
        this.earnedCoins = earnedCoins;
    }

    public int getUsedCoins() {
        return usedCoins;
    }

    public void setUsedCoins(int usedCoins) {
        this.usedCoins = usedCoins;
    }

    public int getAvailableCoins(){
        return earnedCoins - usedCoins;
    }

    public int getProjects() {
        return projects;
    }

    public void setProjects(int projects) {
        this.projects = projects;
    }


}
