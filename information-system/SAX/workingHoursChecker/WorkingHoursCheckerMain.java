import javax.xml.parsers.SAXParserFactory;
import javax.xml.parsers.ParserConfigurationException;
import org.xml.sax.SAXException;
import org.xml.sax.XMLReader;
import org.xml.sax.InputSource;
import java.io.IOException;
import java.io.FileNotFoundException;

/**
 * @author Haoze Zhang
 * @version 24-11-2016
 * Class WorkingHoursCheckerMain, contains main function to initiate SAX parser
 */
public class WorkingHoursCheckerMain {


/**
 * Main function to initiate SAX parsing
 * @param args Takes 1 argument, path to the xml file
 */
public static void main(String[] args){
    if (args.length != 1) { // Wrong usage
                System.out.println("Usage: java WorkingHoursCheckerMain <xmlFile>");
                System.exit(0);
    }
    try {
        SAXParserFactory spf = SAXParserFactory.newInstance();
        spf.setNamespaceAware(true);

		XMLReader xmlReader = spf.newSAXParser().getXMLReader();
		xmlReader.setContentHandler(new WorkingHoursChecker());
		xmlReader.parse(new InputSource(args[0]));

        } catch (ParserConfigurationException pce) {
                System.out.println(pce.getMessage());
        } catch (SAXException se) {
                System.out.println(se.getMessage());
        } catch (FileNotFoundException fnfe) {
                System.out.println(fnfe.getMessage());
        } catch (IOException ioe) {
                System.out.println(ioe.getMessage());
        }

  }
}