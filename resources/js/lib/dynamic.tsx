import { lazy, Suspense, type ComponentType } from "react";

type DynamicImport<T> = () => Promise<{ default: ComponentType<T> }>;

type DynamicOptions = {
  loading?: ComponentType;
};

export default function dynamic<T extends object = {}>(
  importer: DynamicImport<T>,
  options: DynamicOptions = {},
) {
  const { loading: Loading = () => <div /> } = options;

  const LazyComponent = lazy(importer);

  const DynamicWrapper = (props: T) => (
    <Suspense fallback={<Loading />}>
      <LazyComponent {...props} />
    </Suspense>
  );

  return DynamicWrapper;
}
