MessageInterface
  x getProtocolVersion
    getBody
  x getHeaders
  x hasHeader
  x getHeader
  x getHeaderAsArray

IncomingRequestInterface extends MessageInterface
  x getMethod
  x getUrl
  x getServerParams
  x getCookieParams
  x getQueryParams
    getFileParams
    getBodyParams
    getAttributes
    getAttribute
    setAttributes
    setAttribute

OutgoingResponseInterface extends MessageInterface
    setProtocolVersion
  x getStatusCode
    setStatus
    getReasonPhrase
    setHeader
    removeHeader
    setBody

OutgoingRequestInterface extends MessageInterface
    setProtocolVersion
  x getMethod
    setMethod
  x getUrl
    setUrl
    setHeader
    addHeader
    removeHeader
    setBody

IncomingResponseInterface extends MessageInterface
  x getStatusCode
  x getReasonPhrase
