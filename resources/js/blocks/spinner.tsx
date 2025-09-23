import { SpinnerRoot } from "@narsil-cms/components/spinner";

type SpinnerProps = React.ComponentProps<typeof SpinnerRoot> & {};

function Spinner({ ...props }: SpinnerProps) {
  return <SpinnerRoot {...props} />;
}

export default Spinner;
