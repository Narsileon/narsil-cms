import { ProgressIndicator, ProgressRoot, ProgressTrack } from "@narsil-cms/components/progress";
import { type ComponentProps } from "react";

function Progress({ children, ...props }: ComponentProps<typeof ProgressRoot>) {
  return (
    <ProgressRoot {...props}>
      {children}
      <ProgressTrack>
        <ProgressIndicator />
      </ProgressTrack>
    </ProgressRoot>
  );
}

export default Progress;
