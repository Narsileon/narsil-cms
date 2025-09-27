import { type ComponentProps } from "react";

import { SpinnerRoot } from "@narsil-cms/components/spinner";

type SpinnerProps = ComponentProps<typeof SpinnerRoot> & {};

function Spinner({ ...props }: SpinnerProps) {
  return <SpinnerRoot {...props} />;
}

export default Spinner;
