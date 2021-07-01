package gui;

import com.sun.javafx.stage.EmbeddedWindow;
import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.stage.Stage;

import java.io.IOException;
import java.util.Objects;

public class Main extends Application {


    private Stage primaryStage;

    @Override
    public void start(Stage primaryStage) throws Exception{
        this.primaryStage = primaryStage;

        try{
            Parent root = FXMLLoader.load(Objects.requireNonNull(getClass().getResource("landing_page.fxml")));
            Scene scene = new Scene(root);
            scene.getStylesheets().add("/assets/css/theme.css");
            primaryStage.setScene(scene);
        }
        catch (IOException e){
            System.out.println("Erreur de chargement: " + e);
        }
        primaryStage.setTitle("Accueil");
        primaryStage.show();
    }

    public void changeScene(String fxml) throws IOException {
        Parent pane = FXMLLoader.load(Objects.requireNonNull(getClass().getResource(fxml)));
        Scene scene = new Scene( pane );
        primaryStage.setScene(scene);
    }


    public static void main(String[] args) {
        launch(args);
    }
}
