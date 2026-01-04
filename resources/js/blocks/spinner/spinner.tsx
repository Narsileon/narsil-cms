import { SpinnerRoot } from "@narsil-cms/components/spinner";
import { type ComponentProps } from "react";

type SpinnerProps = ComponentProps<typeof SpinnerRoot>;

function Spinner({ ...props }: SpinnerProps) {
  return <SpinnerRoot {...props} />;
}

export default Spinner;
