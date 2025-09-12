import {
  ProgressIndicator,
  ProgressRoot,
} from "@narsil-cms/components/progress";

type ProgressProps = React.ComponentProps<typeof ProgressRoot> & {};

function Progress({ className, value, ...props }: ProgressProps) {
  return (
    <ProgressRoot {...props}>
      <ProgressIndicator value={value} />
    </ProgressRoot>
  );
}
export default Progress;
