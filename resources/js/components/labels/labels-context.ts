import * as React from "react";

export type LabelsContextProps = {
  trans: (key: string, fallback?: string) => string;
};

export const LabelsContext = React.createContext<LabelsContextProps>({
  trans: () => "string",
});

function useLabels() {
  const context = React.useContext(LabelsContext);

  if (!context) {
    throw new Error("useLabels must be used within a LabelsProvider");
  }

  return context;
}

export default useLabels;
