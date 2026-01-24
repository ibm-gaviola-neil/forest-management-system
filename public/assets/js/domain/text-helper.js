/**
 * Get the first 2 initials from a person's full name
 * 
 * This function extracts the first letter of the first two parts of a name.
 * For example:
 * - "Neil Bryan Gaviola" becomes "NB" (first two name parts only)
 * - "April Debian" becomes "AD" (both name parts)
 * - "John" becomes "J" (single name part)
 *
 * @param {string} fullName - The full name to extract initials from
 * @param {boolean} uppercase - Whether to return uppercase initials (default: true)
 * @return {string} The extracted initials (maximum of 2 characters)
 */
export function getInitials(fullName, uppercase = true) {
    // Return empty string if no name provided
    if (!fullName || typeof fullName !== "string") {
      return "";
    }
    
    // Trim whitespace and split by spaces, hyphens, or other common separators
    const nameParts = fullName.trim().split(/[\s-_]+/);
    
    // Filter out empty parts
    const filteredParts = nameParts.filter(part => part.length > 0);
    
    // Extract the first letter from each part (limit to first 2 parts)
    const initials = filteredParts
      .slice(0, 2) // Take only first 2 parts
      .map(part => part[0]); // Take first character
    
    // Join the letters and apply case formatting if requested
    let result = initials.join("");
    
    // Convert to uppercase if specified (default)
    return uppercase ? result.toUpperCase() : result;
  }