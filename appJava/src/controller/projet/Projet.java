package controller.projet;

public class Projet {
    int id;
    int tarif;
    String name;
    String descriptif;
    String asso_name;


    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getTarif() {
        return tarif;
    }

    public Projet(int id, int tarif, String name, String descriptif, String asso_name) {
        this.id = id;
        this.tarif = tarif;
        this.name = name;
        this.descriptif = descriptif;
        this.asso_name = asso_name;
    }

    public void setTarif(int tarif) {
        this.tarif = tarif;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getDescriptif() {
        return descriptif;
    }

    public void setDescriptif(String descriptif) {
        this.descriptif = descriptif;
    }

    public String getAsso_name() {
        return asso_name;
    }

    public void setAsso_name(String asso_name) {
        this.asso_name = asso_name;
    }
}
