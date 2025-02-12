package controller;

import controller.admin.AdminAssoController;
import controller.admin.AdminIndexController;
import controller.admin.AdminProjectController;
import controller.asso.AssoIndexController;
import controller.asso.AssoNewProjectController;
import controller.asso.AssoPasswordChoiceController;
import controller.project.ProjectIndexController;
import controller.user.UserIndexController;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Node;
import javafx.scene.Scene;
import javafx.scene.layout.AnchorPane;
import javafx.stage.Stage;
import persistence.Asso;
import persistence.Project;
import persistence.User;

import java.io.IOException;
import java.util.Objects;

public class ControllerOne {

    @FXML
    protected AnchorPane mainPane;

    //generic fonction
    public void displayStage(String path, String title, ActionEvent event){
        try {
            FXMLLoader loader = new FXMLLoader(Objects.requireNonNull(getClass().getResource(path)));
            Stage currentStage = (Stage)((Node) event.getSource()).getScene().getWindow();

            Scene scene = new Scene(loader.load());
            scene.getStylesheets().add("/assets/css/theme.css");

            currentStage.setScene(scene);
            currentStage.setTitle(title);
            currentStage.show();
        }
        catch (IOException e){
            System.out.println("Erreur de chargement: " + e);
            e.printStackTrace();
        }
    }
    public void displayStage(String path, String title){
        try {
            FXMLLoader loader = new FXMLLoader(Objects.requireNonNull(getClass().getResource(path)));
            Stage currentStage = (Stage) mainPane.getScene().getWindow();
            Scene scene = new Scene(loader.load());
            scene.getStylesheets().add("/assets/css/theme.css");

            currentStage.setScene(scene);
            currentStage.setTitle(title);
            currentStage.show();
        }
        catch (IOException e){
            System.out.println("Erreur de chargement: " + e);
            e.printStackTrace();
        }
    }


    //redirection

    @FXML
    public void goToLandingPage(ActionEvent event){
        displayStage("/gui/landing_page.fxml", "Accueil", event);
    }
    public void goToLandingPage(){
        displayStage("/gui/landing_page.fxml", "Accueil" );
    }


    //for user part
    @FXML
    public void goToUserConnexion(ActionEvent event){
        displayStage("/gui/user/user_connexion.fxml", "Connexion", event);
    }
    public void goToUserConnexion(){
        displayStage("/gui/user/user_connexion.fxml", "Connexion");
    }

    public static void loadUserIndex(ActionEvent event, User user){
        try {
            FXMLLoader loader = new FXMLLoader(Objects.requireNonNull(ControllerOne.class.getResource("/gui/user/user_index.fxml")));
            Stage currentStage = (Stage)((Node) event.getSource()).getScene().getWindow();
            Scene scene = new Scene(loader.load());
            scene.getStylesheets().add("/assets/css/theme.css");

            currentStage.setScene(scene);
            currentStage.setTitle(user.getUsername());

            UserIndexController newController = loader.getController();
            newController.initData(user);

            currentStage.show();
        }
        catch (IOException e){
            System.out.println("Erreur de chargement: " + e);
        }
    }

    @FXML
    public void goToAssoConnexion(ActionEvent event){
        displayStage("/gui/asso/asso_connexion.fxml", "Association | Connexion",event);
    }

    @FXML
    public void goToAssoInscription(ActionEvent event){
        displayStage("/gui/asso/asso_inscription.fxml", "Association | Inscription", event);
    }

    public static void loadAssoPaswordChoice(ActionEvent event, Asso asso){
        try {
            FXMLLoader loader = new FXMLLoader(Objects.requireNonNull(ControllerOne.class.getResource("/gui/asso/asso_password_choice.fxml")));
            Stage currentStage = (Stage)((Node) event.getSource()).getScene().getWindow();
            Scene scene = new Scene(loader.load());
            scene.getStylesheets().add("/assets/css/theme.css");

            currentStage.setScene(scene);
            currentStage.setTitle("Association | Choix du mot de passe");

            AssoPasswordChoiceController newController = loader.getController();
            newController.initData(asso);

            currentStage.show();
        }
        catch (IOException e){
            System.out.println("Erreur de chargement: " + e);
        }
    }


    public static void loadAssoIndex(ActionEvent event, Asso asso){
        try {
            FXMLLoader loader = new FXMLLoader(Objects.requireNonNull(ControllerOne.class.getResource("/gui/asso/asso_index.fxml")));
            Stage currentStage = (Stage)((Node) event.getSource()).getScene().getWindow();
            Scene scene = new Scene(loader.load());
            scene.getStylesheets().add("/assets/css/theme.css");

            currentStage.setScene(scene);
            currentStage.setTitle(asso.getName());

            AssoIndexController newController = loader.getController();
            newController.initData(asso);

            currentStage.show();
        }
        catch (IOException e){
            System.out.println("Erreur de chargement: " + e);
        }
    }
    public static void loadAssoIndex(ActionEvent event, Asso asso, String successMsg){
        try {
            FXMLLoader loader = new FXMLLoader(Objects.requireNonNull(ControllerOne.class.getResource("/gui/asso/asso_index.fxml")));
            Stage currentStage = (Stage)((Node) event.getSource()).getScene().getWindow();
            Scene scene = new Scene(loader.load());
            scene.getStylesheets().add("/assets/css/theme.css");

            currentStage.setScene(scene);
            currentStage.setTitle(asso.getName());

            AssoIndexController newController = loader.getController();
            newController.initData(asso);
            newController.successMsg.setText(successMsg);

            currentStage.show();
        }
        catch (IOException e){
            System.out.println("Erreur de chargement: " + e);
        }
    }


    public static void loadAssoNewProjectStage(ActionEvent event, Asso asso){
        try {
            FXMLLoader loader = new FXMLLoader(Objects.requireNonNull(ControllerOne.class.getResource("/gui/asso/asso_new_project.fxml")));
            Stage currentStage = (Stage)((Node) event.getSource()).getScene().getWindow();
            Scene scene = new Scene(loader.load());
            scene.getStylesheets().add("/assets/css/theme.css");

            currentStage.setScene(scene);
            currentStage.setTitle(asso.getName() + " | Nouveau Projet");

            AssoNewProjectController newController = loader.getController();
            newController.initData(asso);

            currentStage.show();
        }
        catch (IOException e){
            System.out.println("Erreur de chargement: " + e);
        }
    }

    //for admin part
    public static void loadAdminIndex(ActionEvent event, User admin){
        try {
            FXMLLoader loader = new FXMLLoader(Objects.requireNonNull(ControllerOne.class.getResource("/gui/admin/admin_index.fxml")));
            Stage currentStage = (Stage)((Node) event.getSource()).getScene().getWindow();
            Scene scene = new Scene(loader.load());
            scene.getStylesheets().add("/assets/css/theme.css");

            currentStage.setScene(scene);
            currentStage.setTitle("Admin | " + admin.getUsername());

            AdminIndexController newController = loader.getController();
            newController.initData(admin);

            currentStage.show();
        }
        catch (IOException e){
            System.out.println("Erreur de chargement: " + e);
        }
    }

    public static void loadAdminProject(ActionEvent event, Project project, User admin){
        try {
            FXMLLoader loader = new FXMLLoader(Objects.requireNonNull(ControllerOne.class.getResource("/gui/admin/admin_project.fxml")));
            Stage currentStage = (Stage)((Node) event.getSource()).getScene().getWindow();
            Scene scene = new Scene(loader.load());
            scene.getStylesheets().add("/assets/css/theme.css");

            currentStage.setScene(scene);
            currentStage.setTitle("Admin | " + admin.getUsername());

            AdminProjectController newController = loader.getController();
            newController.initData(project, admin);

            currentStage.show();
        }
        catch (IOException e){
            System.out.println("Erreur de chargement: " + e);
        }
    }

    public static void loadAdminAsso(ActionEvent event, Asso asso, User admin){
        try {
            FXMLLoader loader = new FXMLLoader(Objects.requireNonNull(ControllerOne.class.getResource("/gui/admin/admin_asso.fxml")));
            Stage currentStage = (Stage)((Node) event.getSource()).getScene().getWindow();
            Scene scene = new Scene(loader.load());
            scene.getStylesheets().add("/assets/css/theme.css");

            currentStage.setScene(scene);
            currentStage.setTitle("Admin | " + admin.getUsername());

            AdminAssoController newController = loader.getController();
            newController.initData(asso, admin);

            currentStage.show();
        }
        catch (IOException e){
            System.out.println("Erreur de chargement: " + e);
        }
    }



    //for projects
    public static void loadProjectIndex(ActionEvent event, Project project){

        try {
            FXMLLoader loader = new FXMLLoader(Objects.requireNonNull(ControllerOne.class.getResource("/gui/project/project_index.fxml")));
            Stage currentStage = (Stage)((Node) event.getSource()).getScene().getWindow();
            Scene scene = new Scene(loader.load());
            scene.getStylesheets().add("/assets/css/theme.css");

            currentStage.setScene(scene);

            currentStage.setTitle(project.getName());

            ProjectIndexController newController = loader.getController();
            newController.initData(project);

            currentStage.show();
        }
        catch (IOException e){
            System.out.println("Erreur de chargement: " + e);
        }
    }

    public static void loadProjectIndex(ActionEvent event, Project project, User user){

        try {
            FXMLLoader loader = new FXMLLoader(Objects.requireNonNull(ControllerOne.class.getResource("/gui/project/project_index.fxml")));
            Stage currentStage = (Stage)((Node) event.getSource()).getScene().getWindow();
            Scene scene = new Scene(loader.load());
            scene.getStylesheets().add("/assets/css/theme.css");

            currentStage.setScene(scene);

            currentStage.setTitle(project.getName());

            ProjectIndexController newController = loader.getController();
            newController.initData(project, user);

            currentStage.show();
        }
        catch (IOException e){
            System.out.println("Erreur de chargement: " + e);
        }
    }

    public static void loadProjectIndex(Stage currentStage, Project project, Asso asso){

        try {
            FXMLLoader loader = new FXMLLoader(Objects.requireNonNull(ControllerOne.class.getResource("/gui/project/project_index.fxml")));
            Scene scene = new Scene(loader.load());
            scene.getStylesheets().add("/assets/css/theme.css");

            currentStage.setScene(scene);
            currentStage.setScene(scene );

            currentStage.setTitle(project.getName());

            ProjectIndexController newController = loader.getController();
            newController.initData(project, asso);

            currentStage.show();
        }
        catch (IOException e){
            System.out.println("Erreur de chargement: " + e);
        }
    }
}
