import java.util.Stack;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;


public class WorkingHoursChecker extends DefaultHandler {

  int hoursTotals = 0;
  int numberOfEmps = 0;
  Stack<String> lastNames = new Stack<String>();
  boolean takeHour = false;
  boolean takeName = false;

  public void startDocument( ) throws SAXException {
	  System.out.println("Parsing Starts!");
	  System.out.println("Calculating average working hour/week");
	  System.out.println("And poor guys who work more than 40 hours/week");
  }

  public void endDocument( ) throws SAXException {
	  if (numberOfEmps == 0) {
		  System.out.println("No employee!");
		  return;
	  }
	  System.out.println("Result:");
	  System.out.println("Average working hour is " + hoursTotals / numberOfEmps + " hours/week");
	  System.out.println("These people work 40+ hours per week:");
	  for (String ln: lastNames) {
		  System.out.println(ln);
	  }
  }


  public void startElement(String namespaceURI, String localName,
                           String qName, Attributes attr )
  throws SAXException {
	  if (localName.equals("employee")) {
		  numberOfEmps++;
	  }
	  if (localName.equals("hoursPerWeek")) {
		  takeHour = true;
	  }
	  if (localName.equals("lastName")) {
		  takeName = true;
	  }
  }


  public void endElement(String namespaceURI, String localName,
                         String qName ) throws SAXException {

  }


  public void characters(char[] ch, int start, int length )
  throws SAXException {
	  if (takeHour) {
		  String hoursString = new String(ch, start, length);
		  hoursString = hoursString.trim();
		  int hours = new Integer(hoursString);
		  hoursTotals += hours;
		  if (hours <= 40) {
			  lastNames.pop();
		  }
		  takeHour = false;
	  }
	  if (takeName) {
		  String nameString = new String(ch, start, length);
		  lastNames.add(nameString);
		  takeName = false;
	  }
  }
}
