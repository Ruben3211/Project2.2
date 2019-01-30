package server;

import java.io.BufferedOutputStream;
import java.io.FileOutputStream;
import java.io.IOException;

public class writeToFile {

    public static synchronized void write(byte[] receivedData, String newfile, String strFileContents, int num, BufferedOutputStream bos){

        strFileContents += new String(receivedData, 0, num);
        String[] stringsel = strFileContents.split("(?<=</MEASUREMENT>)");

        try {
            for(int m = 0; m < 10; m++){
                    String reqString = stringsel[m].substring(stringsel[m].indexOf("<STN>") + 5 , stringsel[m].indexOf("</STN>"));
                if (MultiThreadedServer.checkarray(reqString)) {

                    //System.out.println(stringsel[m]);


                    MultiThreadedServer.bufferForFile.add(stringsel[m]);
                    System.out.println(MultiThreadedServer.bufferForFile.size());

                    //MultiThreadedServer.fillarray(bufferForFile,stringsel[m]);
                    if(MultiThreadedServer.bufferForFile.size() > 170) {
                        String multiToString = MultiThreadedServer.bufferForFile.toString();

//                        Strip string to generate a good XML file
                        multiToString = multiToString.replace(",", "");  //remove the commas
                        multiToString = multiToString.replace("[", ""); //remove the right bracket
                        multiToString = multiToString.replace("]", "");  //remove the left bracket
                        multiToString = multiToString.replace("<?xml version=\"1.0\"?>", "");  //remove the random xml tags
                        multiToString = multiToString.replace("<WEATHERDATA>", "");  //remove the random xml tags
                        multiToString = multiToString.replace("</WEATHERDATA>", "");  //remove the random xml tags
                        multiToString = multiToString.trim();           //remove trailing spaces from partially initialized arrays


                        multiToString = "<WEATHERDATA>" + "\n" + "\t" + multiToString;
                        multiToString = "<?xml version=\"1.0\"?>" + "\n" + multiToString;
                        multiToString = multiToString + "\n" + "</WEATHERDATA>" ;


                        bos = new BufferedOutputStream(new FileOutputStream(newfile));
                        bos.write(multiToString.getBytes(), 0, multiToString.length());
                        bos.close();
                        System.out.println("Cleared array list");
                        deleteArray();
                        // /MultiThreadedServer.bufferForFile.clear();

                    }
                }
            }
            //bis.close();
        } catch (IOException e) {
            //report exception somewhere.
            e.printStackTrace();
        }


//                END FILTER CODE

    }

    public static synchronized void deleteArray(){
        MultiThreadedServer.bufferForFile.clear();
    }

}
