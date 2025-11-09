import { createGraphiQLFetcher } from "@graphiql/toolkit";
import { useThemeStore } from "@narsil-cms/stores/theme-store";
import { GraphiQL } from "graphiql";

import "graphiql/style.css";

function GraphiQLPage() {
  const { theme } = useThemeStore();

  const fetcher = createGraphiQLFetcher({
    url: "/narsil/graphql",
  });

  return (
    <GraphiQL
      editorTheme={{
        dark: "vs-dark",
        light: "vs",
      }}
      fetcher={fetcher}
      forcedTheme={theme}
    />
  );
}

export default GraphiQLPage;
