package controller;

import controller.asso.AssoPasswordChoiceController;
import controller.user.UserIndexController;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Node;
import javafx.scene.Scene;
import javafx.stage.Stage;
import persistence.Asso;
import persistence.User;

import java.io.IOException;
import java.util.Objects;

public class ControllerOne {

    public Object object;

    public void initData(Object object){
        this.object = object;
    }


    //generic fonction
    public void displayStage(String path, String title, ActionEvent event){
        try {
            FXMLLoader loader = new FXMLLoader(Objects.requireNonNull(getClass().getResource(path)));
            Stage currentStage = (Stage)((Node) event.getSource()).getScene().getWindow();

            currentStage.setScene(new Scene(loader.load()));
            currentStage.setTitle(title);
            currentStage.show();
        }
        catch (IOException e){
            System.out.println("Erreur de chargement: " + e);
            e.printStackTrace();
        }
    }

    public void displayStage(String path, String title, Node node){
        try {
            FXMLLoader loader = new FXMLLoader(Objects.requireNonNull(getClass().getResource(path)));
            Stage currentStage = (Stage) node.getScene().getWindow();

            currentStage.setScene(new Scene(loader.load()));
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


    //for user part
    @FXML
    public void goToUserConnexion(ActionEvent event){
        displayStage("/gui/user/user_connexion.fxml", "Connexion", event);
    }
    @FXML
    public void goToUserConnexion(Node node){
        displayStage("/gui/user/user_connexion.fxml", "Connexion", node);
    }

    public static void goToUserIndex(ActionEvent event, User user){
        try {
            FXMLLoader loader = new FXMLLoader(Objects.requireNonNull(ControllerOne.class.getResource("/gui/user/user_index.fxml")));
            Stage currentStage = (Stage) ((Node) event.getSource()).getScene().getWindow();
            currentStage.setScene(new Scene(loader.load()));
            currentStage.setTitle(user.getUsername());

            UserIndexController newController = loader.getController();
            newController.initData(user);

            currentStage.show();
        }
        catch (IOException e){
            System.out.println("Erreur de chargement: " + e);
        }
    }


    //for asso part
    @FXML
    public void goToAssoConnexion(ActionEvent event){
        displayStage("/gui/asso/asso_connexion.fxml", "Association | Connexion",event);
    }

    @FXML
    public void goToAssoInscription(ActionEvent event){
        displayStage("/gui/asso/asso_inscription.fxml", "Association | Inscription", event);
    }

    public static void goToAssoPaswordChoice(ActionEvent event, Asso asso){
        try {
            FXMLLoader loader = new FXMLLoader(Objects.requireNonNull(ControllerOne.class.getResource("/gui/asso/asso_password_choice.fxml")));
            Stage currentStage = (Stage)((Node) event.getSource()).getScene().getWindow();
            Scene scene = new Scene(loader.load());
            currentStage.setScene(scene );
            currentStage.setTitle("Association | Choix du mot de passe");

            AssoPasswordChoiceController newController = loader.getController();
            newController.initData(asso);

            currentStage.show();
        }
        catch (IOException e){
            System.out.println("Erreur de chargement: " + e);
        }
    }
}
