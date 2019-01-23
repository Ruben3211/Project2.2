package server;

public class main {
    public static void main(String[] args) {
        MultiThreadedServer server = new MultiThreadedServer(3333);
        new Thread(server).start();
    }
}
