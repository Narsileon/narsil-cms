import { createGraphiQLFetcher } from "@graphiql/toolkit";
import { GraphiQL } from "graphiql";
import "graphiql/style.css";

function GraphiQLPage() {
  const fetcher = createGraphiQLFetcher({
    url: "/narsil/graphql",
  });

  return <GraphiQL fetcher={fetcher} />;
}

export default GraphiQLPage;
