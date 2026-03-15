import { dynamic } from "@narsil-ui/lib/dynamic";

const LazyGraphiQLPage = dynamic(() => import("@narsil-cms/components/graphql/graphiql"));

function Index() {
  return <LazyGraphiQLPage />;
}

export default Index;
