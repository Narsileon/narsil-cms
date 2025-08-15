import { createGraphiQLFetcher } from "@graphiql/toolkit";
import { GraphiQL } from "graphiql";
import "graphiql/style.css";

export default function GraphiQLPage() {
  const fetcher = createGraphiQLFetcher({ url: "/narsil/graphql" });

  return <GraphiQL fetcher={fetcher} />;
}
