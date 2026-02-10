import { dynamic } from "@narsil-ui/lib/dynamic";

const LazyGraphiQLPage = dynamic(() => import("@narsil-cms/blocks/graphiql"));

function Index() {
  return <LazyGraphiQLPage />;
}

export default Index;
