<?xml version="1.0" ?>
<xsl:stylesheet 
  version="1.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
>

  <xsl:template match="/">
    <xsl:text disable-output-escaping="yes">&lt;!DOCTYPE html></xsl:text>
    <html>
      <head>
        <title><xsl:value-of select="/careers/@title" /></title>
      </head>
      <body>
        <h1><xsl:value-of select="/careers/@title" /></h1>
        <xsl:apply-templates />
      </body>
    </html>
  </xsl:template>

  <xsl:template match="careers">
    <xsl:apply-templates />
  </xsl:template>
  
  <xsl:template match="message">
    <h4><xsl:apply-templates /></h4>
  </xsl:template>

  <xsl:template match="job">
    <h3><xsl:value-of select="title" /></h3>
    <xsl:apply-templates select="para" />
  </xsl:template>

  <xsl:template match="para">
  	<ul>
    <p><li><xsl:value-of select="text()" /></li></p>
    </ul>
  </xsl:template>


</xsl:stylesheet>
