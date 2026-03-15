import { createGraphiQLFetcher } from "@graphiql/toolkit";
import { useThemeStore } from "@narsil-ui/stores/theme-store";
import { GraphiQL as GraphiQLPrimitive } from "graphiql";

import "graphiql/style.css";

function GraphiQL() {
  const { theme } = useThemeStore();

  const fetcher = createGraphiQLFetcher({
    url: "/admin/graphql",
  });

  return (
    <GraphiQLPrimitive
      editorTheme={{
        dark: "vs-dark",
        light: "vs",
      }}
      fetcher={fetcher}
      forcedTheme={theme}
    />
  );
}

export default GraphiQL;
